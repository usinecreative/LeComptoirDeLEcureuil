<?php

namespace JK\CmsBundle\Controller;

use LAG\AdminBundle\Action\ActionInterface;
use LAG\AdminBundle\Action\Configuration\ActionConfiguration;
use LAG\AdminBundle\Admin\AdminInterface;
use LAG\AdminBundle\Controller\CRUDController;
use LAG\AdminBundle\Field\FieldInterface;
use LAG\AdminBundle\Responder\ResponderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends CRUDController implements ActionInterface
{
    /**
     * Return the Media gallery for the modal (no layout used).
     *
     * @return Response
     */
    public function modalGalleryAction()
    {
        $mediaList = $this
            ->get('cms.media.media_repository')
            ->findAll();

        return $this->render('@JKCms/Media/modalGallery.html.twig', [
            'mediaList' => $mediaList,
        ]);
    }

    /**
     * Return the content that should be inserted into a tinyMce instance.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function galleryContentAction(Request $request)
    {
        $idsString = $request->get('ids', '');
        $ids = explode(',', $idsString);

        $mediaList = $this
            ->get('cms.media.media_repository')
            ->findBy([
                'id' => $ids,
            ])
        ;

        return $this->render('@JKCms/Media/galleryContent.html.twig', [
            'mediaList' => $mediaList,
        ]);
    }

    /**
     * Display the Media list for the Admin.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $admin = $this->getAdminFromRequest($request);
        $admin->handleRequest($request);
        //$con = $this->get('lag.admin.configuration_factory')->createActionConfiguration();
        //$admin->getCurrentAction()->setConfiguration();
        
        return $this->render('@JKCms/Media/list.html.twig', [
            'admin' => $admin,
        ]);
        
        
        // TODO remove this method when AdminBundle can handle template configuration (v0.5)
        $viewParameters = parent::listAction($request);

        if ($viewParameters instanceof Response) {
            return $viewParameters;
        }

        /** @var AdminInterface $admin */
        $admin = $viewParameters['admin'];
        $viewParameters['mediaEditAction'] = $admin->generateRouteName('edit');

        return $this->render('@JKCms/Media/list.html.twig', $viewParameters);
    }

    /**
     * Edit a Media.
     *
     * @param Request $request
     *
     * @return array|RedirectResponse|Response
     */
    public function editAction(Request $request)
    {
        // TODO remove this method when AdminBundle can handle template configuration (v0.5)
        $viewParameters = parent::editAction($request);

        if ($viewParameters instanceof Response) {
            return $viewParameters;
        }
        $viewParameters['linkedArticles'] = '';

        return $this->render('@JKCms/Media/edit.html.twig', $viewParameters);
    }

    /**
     * Create a new Media.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $admin = $this->getAdminFromRequest($request);
        $admin->handleRequest($request, $this->getUser());

        // check permissions
        $this->forward404IfNotAllowed($admin);

        // create form
        $formType = $admin
            ->getConfiguration()
            ->getParameter('form');
        $form = $this->createForm($formType, $admin->create());
        $form->handleRequest($request);

        if ($form->isValid()) {
            // save entity
            $success = $admin->save();

            if ($success) {
                // if save is pressed, user stay on the edit view
                if ($request->request->get('submit') == 'save') {
                    $editRoute = $admin->generateRouteName('edit');

                    return $this->redirectToRoute($editRoute, [
                        'id' => $admin->getUniqueEntity()->getId(),
                    ]);
                } else {
                    // otherwise user is redirected to list view
                    $listRoute = $admin->generateRouteName('list');

                    return $this->redirectToRoute($listRoute);
                }
            }
        }

        return $this->render('@JKCms/Media/create.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Define the Action configuration.
     *
     * @param ActionConfiguration $actionConfiguration
     */
    public function setConfiguration(ActionConfiguration $actionConfiguration)
    {
        // TODO: Implement setConfiguration() method.
    }
    
    /**
     * Return the Action's configuration.
     *
     * @return ActionConfiguration
     */
    public function getConfiguration()
    {
        // TODO: Implement getConfiguration() method.
    }
    
    /**
     * Return true if the Action require entity loading.
     *
     * @return bool
     */
    public function isLoadingRequired()
    {
        // TODO: Implement isLoadingRequired() method.
    }
    
    /**
     * The Action's name.
     *
     * @return string
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }
    
    /**
     * @return FieldInterface[]
     */
    public function getFields()
    {
        // TODO: Implement getFields() method.
    }
    
    /**
     * @param FieldInterface[] $fields
     */
    public function setFields(array $fields)
    {
        // TODO: Implement setFields() method.
    }
    
    /**
     * @param AdminInterface $admin
     */
    public function setAdmin(AdminInterface $admin)
    {
        // TODO: Implement setAdmin() method.
    }
    
    /**
     * @return AdminInterface
     */
    public function getAdmin()
    {
        // TODO: Implement getAdmin() method.
    }
    
    /**
     * @return ResponderInterface
     */
    public function getResponder()
    {
        // TODO: Implement getResponder() method.
    }
    
    /**
     * @param ResponderInterface $responder
     */
    public function setResponder(ResponderInterface $responder)
    {
        // TODO: Implement setResponder() method.
    }
}
