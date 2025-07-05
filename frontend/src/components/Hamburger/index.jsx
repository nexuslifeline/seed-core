import Styles from './Hamburger.module.scss';
import classNames from 'classnames';

const Hamburger = ({ isArrow }) => {
  return (
    <div className={classNames(Styles.hamburger, isArrow && Styles.isActive)}>
      <span className={Styles.line}></span>
      <span className={Styles.line}></span>
      <span className={Styles.line}></span>
    </div>
  );
};

export default Hamburger;
