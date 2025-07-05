import Styles from '../Button.module.scss';
import classNames from 'classnames';
import { iconPlacements } from './contants';
import { Fragment } from 'react';
import PropTypes from 'prop-types';

const ButtonContent = ({ label, icon, iconPlacement }) => {
  const isIconLeft = iconPlacement === iconPlacements.LEFT;

  return (
    <Fragment>
      {icon && isIconLeft && <span className={classNames(Styles.icon, Styles.iconLeft)}>{icon}</span>}
      {label}
      {icon && !isIconLeft && <span className={classNames(Styles.icon, Styles.iconRight)}>{icon}</span>}
    </Fragment>
  );
};

ButtonContent.propTypes = {
  label: PropTypes.string,
  iconPlacement: PropTypes.string,
  icon: PropTypes.any,
};

export default ButtonContent;
