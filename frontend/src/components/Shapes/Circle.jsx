import Styles from './Circle.module.scss';

const Circle = ({ ...props }) => {
  return <div className={Styles.circle} style={{ ...props }} />;
};

export default Circle;
