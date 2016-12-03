<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Partner;
use AppBundle\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class MainController extends Controller
{
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
     *
     * @param Request $request
     *
     * @return array
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->sendContactMail($form->getData());
            $this->addFlash('success', $this->translate('lecomptoir.contact.message_send'));
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * Display the partner page.
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
     * @return BinaryFileResponse
     */
    public function sitemapAction()
    {
        $sitemap = $this
            ->get('app_sitemap_generator')
            ->generate();
    
        if (!file_exists($sitemap)) {
            throw $this->createNotFoundException('Sitemap not found');
        }
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

    /**
     * @Template(":Main:legal.html.twig")
     */
    public function legalAction()
    {
    }

    /**
     * Return an xml response containing a rss feed with published articles.
     *
     * @return Response
     */
    public function feedAction()
    {
        // get published articles
        $articles = $this
            ->get('jk.cms.article_repository')
            ->findPublished();

        // convert to feed item
        $items = $this
            ->get('jk.cms.feed.article_item_factory')
            ->create($articles);

        // create feed
        $feed = $this
            ->get('eko_feed.feed.manager')
            ->get('article');

        // add loaded articles to the feed
        $feed->addFromArray($items);

        // return xml response
        return new Response($feed->render('rss'));
    }

    /**
     * @param array $data
     */
    protected function sendContactMail(array $data)
    {
        $subject = $this->translate('lecomptoir.mail.contact.title', [
            ':email' => $data['email'],
        ]);
        $body = $this->renderView('Mail/contact.mail.html.twig', $data);
        /** @var Swift_Message $message */
        $message = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($data['email'])
            ->setCc($this->getParameter('admin_mail'))
            ->setTo($this->getParameter('squirrel_mail'))
            ->setBody($body, 'text/html', 'utf8')
        ;
        $this
            ->get('mailer')
            ->send($message);
    }

    /**
     * Throw a 404 Exception if $boolean is false or null.
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
    
    protected function translate($message, array $parameters = [])
    {
        return $this
            ->get('translator')
            ->trans($message, $parameters);
    }
}
