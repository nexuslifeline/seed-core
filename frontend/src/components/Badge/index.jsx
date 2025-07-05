import React from 'react';
import PropTypes from 'prop-types';
import Styles from './Badge.module.scss';
import { variants, variantClasses } from './common/constants';
import classNames from 'classnames';

const Badge = ({ label, variant, ...props }) => {
  return (
    <span className={classNames(Styles.container, variantClasses[variant])} {...props}>
      {label}
    </span>
  );
};

Badge.Variants = variants;

Badge.propTypes = {
  label: PropTypes.string,
  variant: PropTypes.any,
};

Badge.defaultProps = {
  label: 'Badge',
  variant: Badge.Variants.PRIMARY,
};

export default Badge;
