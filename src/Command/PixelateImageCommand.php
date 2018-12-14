<?php

namespace EShop\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class PixelateImageCommand extends Command
{


    protected function configure()
    {
        $this->setName('image:pixelate');
        $this->setDescription('Pixelates an image.');
        $this->setHelp('This command allows you to pixelate an image.');

        $this->addArgument('inputImage', InputArgument::REQUIRED, 'Input image file path');
        $this->addArgument('outputImage', InputArgument::REQUIRED, 'Output image file path');
        $this->addArgument('blockSize', InputArgument::REQUIRED, 'Block size in pixels');
        $this->addOption('advancedPixelation', '-a', InputOption::VALUE_NONE,'Whether to use advanced pixelation effect or not');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputPath = $input->getArgument('inputImage');
        $outputPath = $input->getArgument('outputImage');
        $blockSize = $input->getArgument('blockSize');
        $advancedPixelation = $input->getOption('advancedPixelation');

        $image = $this->createImageFrom($inputPath);
        if ($this->pixelateImage($image, $blockSize, $advancedPixelation)) {
            $this->saveImageTo($image, $outputPath);
        }
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

    private function pixelateImage($image, $blockSize, $advanced) {
        return imagefilter($image, IMG_FILTER_PIXELATE, $blockSize, $advanced);
    }
}