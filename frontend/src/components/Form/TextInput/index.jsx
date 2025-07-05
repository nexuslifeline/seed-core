import React, { forwardRef } from 'react';
import PropTypes from 'prop-types';
import Styles from './TextInput.module.scss';
import classNames from 'classnames';
import InvalidFeedback from '@components/InvalidFeedback';

const TextInput = forwardRef(
  ({ label, containerClassName, error, hideLabel = true, ...props }, ref) => {
    return (
      <div className={classNames(Styles.container, containerClassName)}>
        <input ref={ref} type='text' className={Styles.input} {...props} />
        {!hideLabel && <label className={Styles.label}>{label}</label>}
        {error && <InvalidFeedback error={error} />}
      </div>
    );
  }
);

TextInput.propTypes = {
  label: PropTypes.string,
  containerClassName: PropTypes.string,
  error: PropTypes.string
};

TextInput.Instance = 'TextInput';

export default TextInput;
