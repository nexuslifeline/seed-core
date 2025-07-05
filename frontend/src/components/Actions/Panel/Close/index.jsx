import SharedStyles from '@components/Actions/Shared.module.scss';
import Times from '@components/Icons/Times';
import classNames from 'classnames';

const Close = ({ className, ...props }) => {
  return (
    <button className={classNames(SharedStyles.btn, className)} {...props}>
      <Times className={SharedStyles.icon} />
    </button>
  );
};

export default Close;
