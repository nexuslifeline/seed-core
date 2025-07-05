import React from 'react';
import PropTypes from 'prop-types';
import Styles from './Toggle.module.scss';
import classNames from 'classnames';

const Toggle = ({ label, ...props }) => {
  return (
    <div className={Styles.container}>
      <label className={Styles.switch}>
        <input type='checkbox' {...props} />
        <span className={classNames(Styles.slider, Styles.round)} />
      </label>
      {label && <label className={Styles.label}>{label}</label>}
    </div>
  );
};

Toggle.propTypes = {
  label: PropTypes.string
};

Toggle.Instance = 'Toggle';

export default Toggle;
