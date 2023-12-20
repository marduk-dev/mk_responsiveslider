<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Uploader;

use Marduk\Module\Mk_ResponsiveSlider\Helpers\FileHelper;
use PrestaShop\PrestaShop\Core\Image\Exception\ImageOptimizationException;
use PrestaShop\PrestaShop\Core\Image\Uploader\Exception\ImageUploadException;
use PrestaShop\PrestaShop\Core\Image\Uploader\Exception\MemoryLimitException;
use PrestaShop\PrestaShop\Core\Image\Uploader\Exception\UploadedImageConstraintException;
use PrestaShop\PrestaShop\Core\Image\Uploader\ImageUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MkResponsiveSlideUploader implements ImageUploaderInterface
{
  /**
   * @param string $entityId
   */
  public function upload($entityId, UploadedFile $image)
  {
    $this->checkImageIsAllowedForUpload($image);
    $tempImageName = $this->createTemporaryImage($image);

    $destination = FileHelper::getSlideFilePath($entityId);
    $this->uploadFromTemp($tempImageName, $destination);
  }

  protected function createTemporaryImage(UploadedFile $image)
  {
    $temporaryImageName = tempnam(_PS_TMP_IMG_DIR_, 'PS');

    if (!$temporaryImageName || !move_uploaded_file($image->getPathname(), $temporaryImageName)) {
      throw new ImageUploadException('Failed to create temporary image file');
    }

    return $temporaryImageName;
  }

  /**
   * Uploads resized image from temporary folder to image destination
   *
   * @param $temporaryImageName
   * @param $destination
   *
   * @throws ImageOptimizationException
   * @throws MemoryLimitException
   */
  protected function uploadFromTemp($temporaryImageName, $destination)
  {
    if (!\ImageManager::checkImageMemoryLimit($temporaryImageName)) {
      throw new MemoryLimitException('Cannot upload image due to memory restrictions');
    }

    if (!\ImageManager::resize($temporaryImageName, $destination)) {
      throw new ImageOptimizationException('An error occurred while uploading the image. Check your directory permissions.');
    }

    unlink($temporaryImageName);
  }

  public function deleteImage(string $imageName) {
    $path = FileHelper::getSlideFilePath($imageName);
    if (file_exists($path)) {
      unlink($path);
    }
  }

  /**
   * Check if image is allowed to be uploaded.
   *
   * @param UploadedFile $image
   *
   * @throws UploadedImageConstraintException
   */
  protected function checkImageIsAllowedForUpload(UploadedFile $image)
  {
    $maxFileSize = \Tools::getMaxUploadSize();

    if ($maxFileSize > 0 && $image->getSize() > $maxFileSize) {
      throw new UploadedImageConstraintException(sprintf('Max file size allowed is "%s" bytes. Uploaded image size is "%s".', $maxFileSize, $image->getSize()), UploadedImageConstraintException::EXCEEDED_SIZE);
    }

    if (
      !\ImageManager::isRealImage($image->getPathname(), $image->getClientMimeType())
      || !\ImageManager::isCorrectImageFileExt($image->getClientOriginalName())
      || preg_match('/\%00/', $image->getClientOriginalName()) // prevent null byte injection
    ) {
      throw new UploadedImageConstraintException(sprintf('Image format "%s", not recognized, allowed formats are: .gif, .jpg, .png', $image->getClientOriginalExtension()), UploadedImageConstraintException::UNRECOGNIZED_FORMAT);
    }
  }
}
