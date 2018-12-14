<?php

namespace EShop\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class DrawStarCommand extends Command
{


    protected function configure()
    {
        $this->setName('image:star');
        $this->setDescription('Creates a star.');
        $this->setHelp('This command allows you to create a star by given attributes.');

        // $this->addArgument('inputImage', InputArgument::REQUIRED, 'Input image file path');
        $this->addArgument('outputImage', InputArgument::REQUIRED, 'Output image file path');
        $this->addArgument('width', InputArgument::REQUIRED, 'Width of the star');
        $this->addArgument('color', InputArgument::REQUIRED, 'Color of the star');
        $this->addArgument('bgColor', InputArgument::REQUIRED, 'Background color of the star');
        $this->addArgument('points', InputArgument::REQUIRED, 'Points of the star');
        $this->addArgument('radius', InputArgument::REQUIRED, 'Radius of the star');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $inputPath = $input->getArgument('inputImage');
        $outputPath = $input->getArgument('outputImage');
        $width = $input->getArgument('width');
        $color = $input->getArgument('color');
        $bgColor = $input->getArgument('bgColor');
        $points = $input->getArgument('points');
        $radius = $input->getArgument('radius');

        $image = imagecreatetruecolor($width, $width);
        $color = imagecolorallocate($image, $color[0], $color[1], $color[2]);
        $bgColor = imagecolorallocate($image, $bgColor[0], $bgColor[1], $bgColor[2]);

        imagerectangle($image, 0, 0, $width, $width, $bgColor);

        // $values = _makeFiveSidedStar( $width / 2, 0, $radius, 'star' );

        // imagefilledpolygon($image, )

        $this->saveImageTo($image, $outputPath);
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

    function _makeFiveSidedStar( $x, $y, $radius, $shape='polygon', $spiky=NULL ) {
        // $x, $y co-ords of origin (in pixels), $radius (in pixels), $shape - 'polygon' or 'star', $spikiness - ratio between 0 and 1
        $point = array() ;
        $angle = 360 / 5 ;
        $point[0]['x'] = $x ;
        $point[0]['y'] = $y - $radius ;
        $point[2]['x'] = $x + ( $radius * cos( deg2rad( 90 - $angle ) ) ) ;
        $point[2]['y'] = $y - ( $radius * sin( deg2rad( 90 - $angle ) ) ) ;
        $point[4]['x'] = $x + ( $radius * sin( deg2rad( 180 - ( $angle*2 ) ) ) ) ;
        $point[4]['y'] = $y + ( $radius * cos( deg2rad( 180 - ( $angle*2 ) ) ) ) ;
        $point[6]['x'] = $x - ( $radius * sin( deg2rad( 180 - ( $angle*2 ) ) ) ) ;
        $point[6]['y'] = $y + ( $radius * cos( deg2rad( 180 - ( $angle*2 ) ) ) ) ;
        $point[8]['x'] = $x - ( $radius * cos( deg2rad( 90 - $angle ) ) ) ;
        $point[8]['y'] = $y - ( $radius * sin( deg2rad( 90 - $angle ) ) ) ;
        if( $shape == 'star' ) {
            if( $spiky == NULL ) $spiky = 0.5 ;  // default to 0.5
            $indent = $radius * $spiky ;
            $point[1]['x'] = $x + ( $indent * cos( deg2rad( 90 - $angle/2 ) ) ) ;
            $point[1]['y'] = $y - ( $indent * sin( deg2rad( 90 - $angle/2 ) ) ) ;
            $point[3]['x'] = $x + ( $indent * sin( deg2rad( 180 - $angle ) ) ) ;
            $point[3]['y'] = $y - ( $indent * cos( deg2rad( 180 - $angle ) ) ) ;
            $point[5]['x'] = $x ;
            $point[5]['y'] = $y + ( $indent * sin( deg2rad( 180 - $angle ) ) ) ;
            $point[7]['x'] = $x - ( $indent * sin( deg2rad( 180 - $angle ) ) ) ;
            $point[7]['y'] = $y - ( $indent * cos( deg2rad( 180 - $angle ) ) ) ;
            $point[9]['x'] = $x - ( $indent * cos( deg2rad( 90 - $angle/2 ) ) ) ;
            $point[9]['y'] = $y - ( $indent * sin( deg2rad( 90 - $angle/2 ) ) ) ;
        }
        ksort( $point ) ;
        $coords = array() ;  // new array
        foreach( $point as $pKey=>$pVal ) {
            if( is_array( $pVal ) ) {
                foreach( $pVal as $pSubKey=>$pSubVal ) {
                    if( !empty( $pSubVal ) ) array_push( $coords, $pSubVal ) ;
                }
            }
        }
        return $coords ;
    }
}