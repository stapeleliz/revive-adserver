<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/max/Dal/DataObjects/Banners.php';
require_once 'DataObjectsUnitTestCase.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/tests/util/DataGenerator.php';

/**
 * A class for testing non standard DataObjects_Banners methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 * @TODO No tests written yet...
 */
class DataObjects_BannersTest extends DataObjectsUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_BannersTest()
    {
        $this->UnitTestCase();
    }

    function testDuplicate()
    {
        $id1 = DataGenerator::generateOne(MAX_DB::factoryDO('banners'));
        $this->assertNotEmpty($id1);

        $doBanners = MAX_DB::staticGetDO('banners', $id1);
        $this->assertIsA($doBanners, 'DataObjects_Banners');

        $id2 = $doBanners->duplicate();
        $this->assertNotEmpty($id2);
        $this->assertNotEqual($id1, $id2);

        $doBanners1 = MAX_DB::staticGetDO('banners', $id1);
        $doBanners2 = MAX_DB::staticGetDO('banners', $id2);
        $this->assertNotEqualDataObjects($this->stripKeys($doBanners1), $this->stripKeys($doBanners2));
        
        // make sure the only difference is their description
        $doBanners1->description = null;
        $doBanners2->description = null;
        $this->assertEqualDataObjects($this->stripKeys($doBanners1), $this->stripKeys($doBanners2));

        TestEnv::restoreEnv();
    }
}
