import SVG from 'react-inlinesvg';
import SvgError from '@shared/assets/images/error-404.svg';

const NotFound = (props) => <SVG src={SvgError} {...props} />;

export default NotFound;
