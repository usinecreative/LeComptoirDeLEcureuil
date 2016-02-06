<?php

namespace LeComptoirDeLEcureuil\FrontBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use LeComptoirDeLEcureuil\FrontBundle\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            ->get('lag.cms.article_repository')
            ->findLatest();
        // category configured for display in homepage
        $categories = $this
            ->get('lag.cms.category_repository')
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
     * @Template(":Main:page.html.twig")
     * @param $partnerSlug
     * @return array
     */
    public function partnersAction($partnerSlug = null)
    {
        // TODO find page
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
}
