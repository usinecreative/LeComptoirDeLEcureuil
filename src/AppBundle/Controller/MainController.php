<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Partner;
use BlueBear\BaseBundle\Behavior\ControllerTrait;
use AppBundle\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class MainController extends Controller
{
    use ControllerTrait;

    /**
     * @Template(":Main:index.html.twig")
     * @return array
     */
    public function indexAction()
    {
        // latest published articles
        $latestArticles = $this
            ->get('jk.cms.article_repository')
            ->findLatest();
        // category configured for display in homepage
        $categories = $this
            ->get('jk.cms.category_repository')
            ->findForHomepage();

        return [
            'latestArticles' => $latestArticles,
            'categories' => $categories,
        ];
    }

    /**
     * @Template(":Main:contact.html.twig")
     */
    public function contactAction()
    {
        $form = $this->createForm(ContactType::class);

        if ($form->isValid()) {
            $this->sendContactMail($form->getData());
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * Dislay the partner page.
     *
     * @Template(":Partner:partner.html.twig")
     * @param $partnerSlug
     * @return array
     */
    public function partnerAction($partnerSlug)
    {
        /** @var Partner $partner */
        $partner = $this
            ->get('app_partner_repository')
            ->findOneBy([
                'slug' => $partnerSlug
            ]);
        $this->redirect404Unless($partner, 'lecomptoir.partner.not_found');
        // find linked articles (by tag)
        $articles = $this
            ->get('jk.cms.article_repository')
            ->findByTag($partner->getSlug());

        return [
            'partner' => $partner,
            'articles' => $articles
        ];
    }

    /**
     * @Template(":Main:who-am-i.html.twig")
     */
    public function whoAmIAction()
    {
        return [];
    }

    /**
     * @return array
     */
    public function sitemapAction()
    {
        $sitemap = $this
            ->get('app_sitemap_generator')
            ->generate();
        $this->forward404Unless(file_exists($sitemap));

        $response = new BinaryFileResponse($sitemap);

        $d = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'foo.pdf'
        );
        $response->headers->set('Content-Disposition', $d);
        $response->headers->set('Content-Type', 'text/xml');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'le_comptoir_de_l_ecureuil-sitemap.xml'
        );

        return $response;
    }

    protected function sendContactMail(array $data)
    {
        $message = Swift_Message::newInstance(
            $this->translate('lecomptoir.mail.contact.title', [
                'email' => $data['email']
            ]),
            $this->render('Mail/contact.mail.html.twig', $data),
            'text/html'
        );
        $message->setTo('arnaudfrezet@gmail.com');
        $message->setFrom('contact@lecomptoirdelecureuil');

        $this
            ->get('swiftmailer.mailer')
            ->send($message);
    }

    /**
     * Throw a 404 Exception if $boolean is false or null
     *
     * @param mixed $boolean
     * @param string $message
     */
    protected function redirect404Unless($boolean, $message = '404 Not Found')
    {
        if (!$boolean) {
            throw $this->createNotFoundException($this->translate($message));
        }
    }
}
