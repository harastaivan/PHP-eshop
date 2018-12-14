<?php

namespace EShop\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ResizeImageCommand extends Command
{
    protected function configure()
    {
        $this->setName('image:resize');
        $this->setDescription('Resizes an image.');
        $this->setHelp('This command allows you to resize an image.');

        $this->addArgument('width', InputArgument::REQUIRED, 'Width after resize');
        $this->addArgument('height', InputArgument::REQUIRED, 'Height after resize');
        $this->addArgument('inputImage', InputArgument::REQUIRED, 'Input image file path');
        $this->addArgument('outputImage', InputArgument::REQUIRED, 'Output image file path');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputPath = $input->getArgument('inputImage');
        $outputPath = $input->getArgument('outputImage');
        $width = $input->getArgument('width');
        $height = $input->getArgument('height');

        $inputImage = $this->createImageFrom($inputPath);
        $outputImage = $this->resizeImage($inputImage, $width, $height);
        $this->saveImageTo($outputImage, $outputPath);
    }

    private function getImageExtension($path) {
        $pathInfo = pathinfo($path);
        return $pathInfo['extension'];
    }

    private function createImageFrom($path) {
        $extension = $this->getImageExtension($path);
        switch ($extension) {
            case 'bmp':
                return imagecreatefrombmp($path);
            case 'gd2':
                return imagecreatefromgd2($path);
            case 'gd':
                return imagecreatefromgd($path);
            case 'gif':
                return imagecreatefromgif($path);
            case 'png':
                return imagecreatefrompng($path);
            case 'xbm':
                return imagecreatefromxbm($path);
            default:
                return imagecreatefromjpeg($path);
        }
    }

    private function saveImageTo($image, $path) {
        $extension = $this->getImageExtension($path);
        switch ($extension) {
            case 'bmp':
                return imagebmp($image, $path);
            case 'gd2':
                return imagegd2($image, $path);
            case 'gd':
                return imagegd($image, $path);
            case 'gif':
                return imagegif($image, $path);
            case 'png':
                return imagepng($image, $path);
            case 'xbm':
                return imagexbm($image, $path);
            default:
                return imagejpeg($image, $path);
        }
    }

    private function resizeImage($image, $width, $height) {
        return imagescale($image, $width, $height);
    }
}