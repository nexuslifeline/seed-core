import Styles from './Panels.module.scss';
import classNames from 'classnames';

const Panel = ({ children, className, hasBackground = false }) => {
  return (
    <div className={classNames(Styles.container, hasBackground && Styles.hasBackground, className)}>{children}</div>
  );
};

export default Panel;
