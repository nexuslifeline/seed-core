import Styles from './Rectangle.module.scss';

const Rectangle = ({ ...props }) => {
  return <div className={Styles.rectangle} style={{ ...props }} />;
};

export default Rectangle;
