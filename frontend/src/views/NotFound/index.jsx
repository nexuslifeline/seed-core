import ImageNotFound from '@components/Backgrounds/Images/NotFound';
import Styles from './NotFound.module.scss';

const NotFound = (props) => {
  return (
    <div className={Styles.container}>
      <ImageNotFound className={Styles.bgImage} />
      <p className={Styles.description}>
        Sorry, the page you requested cannot be found. Please go back to homepage or contact us ay support@support.com
      </p>
    </div>
  );
};

export default NotFound;
