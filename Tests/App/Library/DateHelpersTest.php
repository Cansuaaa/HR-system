<?php

namespace Tests\Library\App;

use App\Library\DateHelpers;

class DateHelpersTest extends \Tests\WebTestCase
{

    public function testValidateDateFormatValid()
    {
        $this->assertEquals(true, DateHelpers::validateDateFormat('01/01/2016'));
        $this->assertEquals(true, DateHelpers::validateDateFormat('29/02/2016'));
        $this->assertEquals(true, DateHelpers::validateDateFormat('28/02/2015'));
        $this->assertEquals(true, DateHelpers::validateDateFormat('2016/01/01', 'Y/m/d'));
        $this->assertEquals(true, DateHelpers::validateDateFormat('2016/30/01', 'Y/d/m'));
        $this->assertEquals(true, DateHelpers::validateDateFormat('01-01-2016', 'd-m-Y'));
        $this->assertEquals(true, DateHelpers::validateDateFormat('2016-01-30', 'Y-m-d'));
        $this->assertEquals(true, DateHelpers::validateDateFormat('30.01.2016', 'd.m.Y'));
        $this->assertEquals(true, DateHelpers::validateDateFormat('30?01?2016', 'd?m?Y'));
        $this->assertEquals(true, DateHelpers::validateDateFormat('3/1/2016', 'j/n/Y'));
    }

    public function testValidateDateFormatInvalid()
    {
        $this->assertEquals(false, DateHelpers::validateDateFormat('32/01/2016'));
        $this->assertEquals(false, DateHelpers::validateDateFormat('1/1/16'));
        $this->assertEquals(false, DateHelpers::validateDateFormat('01/01/209999'));
        $this->assertEquals(false, DateHelpers::validateDateFormat('sd/01/2016'));
        $this->assertEquals(false, DateHelpers::validateDateFormat(''));
        $this->assertEquals(false, DateHelpers::validateDateFormat('sdasdfsdf'));
        $this->assertEquals(false, DateHelpers::validateDateFormat('00/00/0000'));
    }
}