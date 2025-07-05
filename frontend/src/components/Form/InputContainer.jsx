import classNames from 'classnames';
import Styles from './shared.module.scss';

const InputContainer = ({ className, children, noMargin, ...props }) => {
  return (
    <div
      className={classNames(
        Styles.inputContainer,
        noMargin && Styles.noMargin,
        className
      )}
      {...props}>
      {children}
    </div>
  );
};

InputContainer.Instance = 'InputContainer';

export default InputContainer;
