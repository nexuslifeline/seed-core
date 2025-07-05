import React from 'react';
import PropTypes from 'prop-types';
import Styles from './PasswordInput.module.scss';
import classNames from 'classnames';

const strengthClasses = {
  strong: Styles.strong,
  medium: Styles.medium,
  weak: Styles.weak,
  veryWeak: Styles.veryWeak,
};

const StrengthBar = ({ strength, size = 0 }) => {
  return (
    <div className={Styles.barContainer}>
      <div style={{ width: `${size}%` }} className={classNames(Styles.strengthBar, strengthClasses[strength])} />
    </div>
  );
};

StrengthBar.propTypes = {
  label: PropTypes.string,
  containerClassName: PropTypes.string,
};

export default StrengthBar;
