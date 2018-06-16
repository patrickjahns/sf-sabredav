<?php

/**
 * @author Patrick Jahns <github@patrickjahns.de>
 *
 * @copyright Copyright (c) 2018, Patrick Jahns.
 * @license GPL-2.0
 *
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 */

namespace App\Controller;

use Sabre\DAV\Browser\Plugin;
use Sabre\DAV\FS\Directory;
use Sabre\DAV\Server;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SabreDavController
{
	private $server;

	public function __construct(ParameterBagInterface $params)
	{

		$rootDirectory = new Directory('sabredav');
		$this->server = new Server($rootDirectory);
		$this->server->setBaseUri('/dav');
		$this->server->addPlugin(new Plugin());
	}

	public function do(Request $request)
	{
		$dav = $this->server;
		$callback = function () use ($dav) {
			$dav->exec();
		};
		$response = new StreamedResponse($callback);
		return $response;
	}


}
