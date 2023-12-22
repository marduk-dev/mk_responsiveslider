<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Controller;

use Marduk\Module\Mk_ResponsiveSlider\Form\SlideDataProvider;
use Marduk\Module\Mk_ResponsiveSlider\Presentation\SlideView;
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
  private SlideView $slideView;

	public function __construct(MkResponsiveSlideRepository $mkResponsiveSlideRepository, Handler $formHandler, SlideDataProvider $dataProvider, SlideView $slideView)
	{
		$this->repository = $mkResponsiveSlideRepository;
    $this->formHandler = $formHandler;
    $this->dataProvider = $dataProvider;
    $this->slideView = $slideView;
	}

  public function index(): Response
  {
    return $this->render('@Modules/mk_responsiveslider/views/templates/admin/index.html.twig', [
      'layoutTitle' => 'Mk_ResponsiveSlider :: slides index',
      'slides' => $this->slideView->all(),
      'max_position' => $this->repository->getNextPosition() - 1,
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

  public function enable(int $slideId): Response
  {
    $slide = $this->repository->get($slideId);
    if ($slide) {
      $slide->enable();
      $this->repository->set($slide);
    }
    return $this->redirectToRoute('mk_responsiveslider_index');
  }

  public function disable(int $slideId): Response
  {
    $slide = $this->repository->get($slideId);
    if ($slide) {
      $slide->disable();
      $this->repository->set($slide);
    }
    return $this->redirectToRoute('mk_responsiveslider_index');
  }

  public function delete(int $slideId): Response
  {
    $this->repository->delete($slideId);
    return $this->redirectToRoute('mk_responsiveslider_index');
  }

  private function move(int $slideId, int $delta) {
    $slide = $this->repository->get($slideId);
    if ($slide) {
      $other = $this->repository->findOneBy(['position' => $slide->getPosition() + $delta]);
      if ($other) {
        $otherPos = $other->getPosition();
        $other->setPosition($slide->getPosition());
        $slide->setPosition($otherPos);

        $this->repository->set($slide);
        $this->repository->set($other);
      }
    }
  }

  public function moveUp(int $slideId): Response
  {
    $this->move($slideId, -1);
    return $this->redirectToRoute('mk_responsiveslider_index');
  }

  public function moveDown(int $slideId): Response
  {
    $this->move($slideId, 1);
    return $this->redirectToRoute('mk_responsiveslider_index');
  }

}
