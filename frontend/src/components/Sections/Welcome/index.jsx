import Styles from './Welcome.module.scss';

const Welcome = ({ title, description }) => {
  return (
    <div className={Styles.container}>
      <h1 style={{ marginBottom: 0 }}>{title}</h1>
      <p>{description}</p>
    </div>
  );
};

export default Welcome;
