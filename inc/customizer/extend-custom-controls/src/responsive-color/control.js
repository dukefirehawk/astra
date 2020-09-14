import ResponsiveColorComponent from './responsive-color-component';
import { astraGetResponsiveColorJs } from '../common/responsive-helper';

export const responsiveColorControl = wp.customize.astraControl.extend( {
	renderContent: function renderContent() {
		let control = this;
		ReactDOM.render(
			<ResponsiveColorComponent control={control} customizer={ wp.customize }/>,
			control.container[0]
		);
	},
	ready: function() {

		astraGetResponsiveColorJs( this );
	},

} );
