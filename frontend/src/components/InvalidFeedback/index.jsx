import React from 'react';
import Styles from './InvalidFeedback.module.scss';

const InvalidFeedback = ({ error, ...props }) => {
  return <span className={Styles.error}>{error}</span>;
};

export default InvalidFeedback;
