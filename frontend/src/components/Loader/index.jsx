import classNames from 'classnames';
import PropTypes from 'prop-types';

const variants = {
  PRIMARY: 'primary',
  WHITE: 'white',
  DARK: 'dark'
};

const Loader = ({ variant, className, ...props }) => {
  return (
    <span
      style={{ ...props }}
      className={classNames('loading__spinner', variant, className)}
    />
  );
};

Loader.Variants = variants;

Loader.propTypes = {
  variant: PropTypes.string
};

Loader.defaultProps = {
  variant: variants.PRIMARY
};

export default Loader;
