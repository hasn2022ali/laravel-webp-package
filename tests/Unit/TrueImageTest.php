<?php

namespace CuttingEdgeTeam\LaravelWebpPackage\Tests;

use PHPUnit\Framework\TestCase;

class TrueImageTest extends TestCase
{
    /** @test*/
    public function trueImage(){
        $filePath = './uploads/img.png';
        $check = getimagesize($filePath);
        $this->assertTrue($check !== false,'File is an image');
        $this->assertArrayHasKey('mime', $check, 'MIME exists');
    }
}