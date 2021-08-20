import getWindow from './window';

export default function getOptions() {
	return getWindow()._Customize_Guide;
}

export function isDisabled( moduleName ) {
	return ( -1 !== getOptions().disabledModules.indexOf( moduleName ) );
}
