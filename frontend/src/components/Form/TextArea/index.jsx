import React, { forwardRef } from 'react';
import PropTypes from 'prop-types';
import Styles from './TextArea.module.scss';
import classNames from 'classnames';
import InvalidFeedback from '@components/InvalidFeedback';

const TextArea = forwardRef(
  ({ label, containerClassName, error, hideLabel = true, ...props }, ref) => {
    return (
      <div className={classNames(Styles.container, containerClassName)}>
        <textarea
          ref={ref}
          className={Styles.input}
          {...props}
          placeholder=' '
        />
        {!hideLabel && <label className={Styles.label}>{label}</label>}
        {error && <InvalidFeedback error={error} />}
      </div>
    );
  }
);

TextArea.propTypes = {
  label: PropTypes.string,
  containerClassName: PropTypes.string,
  error: PropTypes.string
};

TextArea.Instance = 'TextArea';

export default TextArea;
