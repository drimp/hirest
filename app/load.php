<?php
/**
 * Optional includes
 * require files from app directory
 */

hirest()->load('Example/middlewares')
		->load('Example/routes');