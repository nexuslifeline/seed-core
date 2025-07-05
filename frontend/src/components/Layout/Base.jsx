import { Outlet } from 'react-router-dom';
import Styles from './Base.module.scss';
import withTransition from '@shared/hoc/withTransition';

const Base = () => {
  return (
    <div className={Styles.container}>
      <Outlet />
    </div>
  );
};

export default withTransition(Base);
