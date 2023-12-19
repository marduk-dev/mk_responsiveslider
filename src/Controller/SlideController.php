<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Controller;

use Marduk\Module\Mk_ResponsiveSlider\Repository\MkResponsiveSlideRepository;
use PrestaShop\PrestaShop\Core\Form\Handler;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SlideController extends FrameworkBundleAdminController
{
	private $mkResponsiveSlideRepository;

	public function __construct(MkResponsiveSlideRepository $mkResponsiveSlideRepository)
	{
		$this->mkResponsiveSlideRepository = $mkResponsiveSlideRepository;
	}

  public function index(Request $request): Response
  {
    return $this->render('@Modules/mk_responsiveslider/views/templates/admin/index.html.twig', [
      'slides' => $this->mkResponsiveSlideRepository->findAll(),
      'addUrl' => $this->generateUrl('mk_responsiveslider_add')
    ]);
  }

  public function add(Request $request): Response
  {
    $dataHandler = $this->getConfigurationFormHandler();

    $textForm = $dataHandler->getForm();
    $textForm->handleRequest($request);

    if ($textForm->isSubmitted() && $textForm->isValid()) {
      /** You can return array of errors in form handler and they can be displayed to user with flashErrors */
      $errors = $dataHandler->save($textForm->getData());

      if (empty($errors)) {
        $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

        return $this->redirectToRoute('mk_responsiveslider_index');
      }

      $this->flashErrors($errors);
    }

    return $this->render('@Modules/mk_responsiveslider/views/templates/admin/form.html.twig', [
      'slideForm' => $textForm->createView()
    ]);
  }
  protected function getConfigurationFormHandler(): Handler
  {
    $handler = $this->get('marduk.module.mk_responsiveslider.form.slides.form_handler');
    return $handler;
  }
}
