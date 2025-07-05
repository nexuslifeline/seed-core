import Styles from './OverviewSlides.module.scss';
import PropTypes from 'prop-types';

const Slide = ({ title, description }) => {
  return (
    <div className={Styles.slide}>
      <h1 className={Styles.title}>{title}</h1>
      <p className={Styles.description}>{description}</p>
    </div>
  );
};

Slide.propTypes = {
  title: PropTypes.string,
  description: PropTypes.string,
};

export default Slide;
