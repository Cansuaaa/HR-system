<?php
namespace App\Models;
use Yee\Yee;



class ProfileModel
{
    public function getDatabase()
    {
        $database  =  array(
            array(
                'posted'    => '12 minutes ago',
                'today'      => true,
                'timestamp' => '08:33',
                'action'    => 'Added some photos',
                'images'    => array('http://lorempixel.com/50/50/',
                                     'http://lorempixel.com/50/50/',
                                     'http://lorempixel.com/50/50/'),
            ),
            array(
                'posted'    => '17 minutes ago',
                'today'      => false,
                'timestamp' => '09:43',
                'action'    => 'Added extra photos to profile page',
                'images'    => array('http://lorempixel.com/50/50/',
                                     'http://lorempixel.com/50/50/',
                                     'http://lorempixel.com/50/50/',
                                     'http://lorempixel.com/50/50/',
                                     'http://lorempixel.com/50/50/'),
            ),
            array(
                'posted'    => '33 minutes ago',
                'today'      => true,
                'timestamp' => '22:43',
                'action'    => 'Removed photos from profile page',
                'images'    => array('http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',

                ),
            ),
            array(
                'posted'    => '5 minutes ago',
                'today'      => true,
                'timestamp' => '22:43',
                'action'    => 'Removed photos from profile page',
                'images'    => array('http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',

                ),
            ),
            array(
                'posted'    => '5 minutes ago',
                'today'      => false,
                'timestamp' => '22:43',
                'action'    => 'Removed photos from profile page',
                'images'    => array('http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',

                ),
            ),
            array(
                'posted'    => '5 minutes ago',
                'today'      => false,
                'timestamp' => '22:43',
                'action'    => 'Removed photos from profile page',
                'images'    => array('http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',
                    'http://lorempixel.com/50/50/',

                ),
            ),
        );
        return $database;
    }
    public function getSingleUser()
    {
        $singleUser = array(
            'name'          => 'Alexandra',
            'birthday'      => '05.03.1993',
            'joined'        => 'February 16 2016',
            'prevCompany'   => 'Google Inc.',
            'university'    => 'University of Köln',
            'university2'   => 'University of Edelweiß',
            'additionalOne' => 'English Course @ Basile Camp',
            'phone'         => '(+207)391-9167',
            'email'         => 'Alexandra@gmail.com',
            'country'       => 'USA',
            'town'          => 'Maine',
            'postal'        => '04064',
            'image'         => 'http://coderthemes.com/metrico_1.3/images/author.jpg',
            'jobPosition'   => 'Web Designer',
            'summary'       => 'Hi I\'m Alexandra Clarkson,has been the industry\'s standard
             dummy text ever since the 1500s, when an unknown printer took a galley of type.Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
             classical Latin literature from 45 BC,making it over 2000 years old.Contrary to popular belief, Lorem Ipsum is not
             simplyrandom text. It has roots in a piece of classical Latin literature from 45 BC.',
        );
        return $singleUser;
    }
}