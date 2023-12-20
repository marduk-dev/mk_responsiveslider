<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Controller;

use Marduk\Module\Mk_ResponsiveSlider\Form\SlideDataProvider;
use Marduk\Module\Mk_ResponsiveSlider\Repository\MkResponsiveSlideRepository;
use PrestaShop\PrestaShop\Core\Form\Handler;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SlideController extends FrameworkBundleAdminController
{
	private MkResponsiveSlideRepository $repository;
  private Handler $formHandler;
  private SlideDataProvider $dataProvider;

	public function __construct(MkResponsiveSlideRepository $mkResponsiveSlideRepository, Handler $formHandler, SlideDataProvider $dataProvider)
	{
		$this->repository = $mkResponsiveSlideRepository;
    $this->formHandler = $formHandler;
    $this->dataProvider = $dataProvider;
	}

  public function index(Request $request): Response
  {
    return $this->render('@Modules/mk_responsiveslider/views/templates/admin/index.html.twig', [
      'layoutTitle' => 'Mk_ResponsiveSlider :: slides index',
      'slides' => $this->repository->findAll(),
      'addUrl' => $this->generateUrl('mk_responsiveslider_add')
    ]);
  }

  public function add(Request $request): Response
  {
    $this->dataProvider->slideId = null;
    
    $slideForm = $this->formHandler->getForm();
    $slideForm->handleRequest($request);

    if ($slideForm->isSubmitted() && $slideForm->isValid()) {
      /** You can return array of errors in form handler and they can be displayed to user with flashErrors */
      $errors = $this->formHandler->save($slideForm->getData());

      if (empty($errors)) {
        $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

        return $this->redirectToRoute('mk_responsiveslider_index');
      }

      $this->flashErrors($errors);
    }

    return $this->render('@Modules/mk_responsiveslider/views/templates/admin/form.html.twig', [
      'slideForm' => $slideForm->createView()
    ]);
  }

  public function edit(Request $request): Response
  {
    $this->dataProvider->slideId = $request->get('slideId');

    $slideForm = $this->formHandler->getForm();
    $slideForm->handleRequest($request);

    if ($slideForm->isSubmitted() && $slideForm->isValid()) {
      /** You can return array of errors in form handler and they can be displayed to user with flashErrors */
      $errors = $this->formHandler->save($slideForm->getData());

      if (empty($errors)) {
        $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

        return $this->redirectToRoute('mk_responsiveslider_index');
      }

      $this->flashErrors($errors);
    }

    return $this->render('@Modules/mk_responsiveslider/views/templates/admin/form.html.twig', [
      'slideForm' => $slideForm->createView()
    ]);
  }

}
