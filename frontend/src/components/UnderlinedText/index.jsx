import React from 'react';
import Styles from './UnderlinedText.module.scss';
import PropTypes from 'prop-types';

const UnderlinedText = ({ children }) => {
  return <span className={Styles.underlinedText}>{children}</span>;
};

UnderlinedText.propTypes = {
  onRemove: PropTypes.func,
};

export default UnderlinedText;
