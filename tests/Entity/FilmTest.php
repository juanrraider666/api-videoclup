<?php

use App\Entity\Film;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FilmTest extends TestCase
{

    public function testCreateFilm()
    {
        $film = Film::create('Hello world', 'Hello world with php', 200);
        $this->assertEquals(200, $film->getPrice());
        $film = Film::create('Hello world', 'Hello world with php', -2);
        $this->assertEquals(-2, $film->getPrice());
        $film = Film::create('Hello world', 'Hello world with php', null);
        $this->assertEquals(null, $film->getPrice());
    }

    public function testThrowInvalidArgumentExceptionIfInvalid()
    {
        $catched = false;
        try {
            Film::create(1, 'Hello world with php', 200);
        } catch (InvalidArgumentException $exception) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            Score::create(6);
        } catch (InvalidArgumentException $exception) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }

}