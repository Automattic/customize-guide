import $ from 'jquery';
import getAPI from './helpers/api';

import addGuide from './modules/guide';
import getOpts from './helpers/options';
import debugFactory from 'debug';

const debug = debugFactory( 'customize-guide' );
const api = getAPI();

api.bind( 'ready', () => {
	debug( 'customize guide is ready' );

	// Show 'em around the place the first time
	if ( getOpts().showGuide ) {
		addGuide();
	}
} );
