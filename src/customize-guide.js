import $ from 'jquery';

import addGuide from './modules/guide';
import getOpts from './helpers/options';
import debugFactory from 'debug';

const debug = debugFactory( 'customize-guide' );

api.bind( 'ready', () => {
	debug( 'customize guide is ready' );

	// Show 'em around the place the first time
	if ( getOpts().showGuide ) {
		addGuide();
	}
} );
