import Styles from './OverviewSlides.module.scss';
import PropTypes from 'prop-types';
import classNames from 'classnames';

const NavDots = ({ slideCount, currentSlide }) => {
  return (
    <ul className={Styles.dotsContainer}>
      {Array.from({ length: slideCount }).map((_, idx) => (
        <li
          key={idx}
          className={classNames(
            Styles.dotItem,
            idx === currentSlide && Styles.active
          )}
        />
      ))}
    </ul>
  );
};

NavDots.propTypes = {
  slideCount: PropTypes.number,
  activeSlide: PropTypes.number
};

export default NavDots;
