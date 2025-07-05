import classNames from 'classnames';
import Styles from './Field.module.scss';

const FieldGroup = ({ className, label, children, ...props }) => {
  return (
    <div className={classNames(Styles.container, className)} {...props}>
      {label && <label className={Styles.caption}>{label}</label>}
      {children}
    </div>
  );
};

FieldGroup.Instance = 'FieldGroup';

export default FieldGroup;
