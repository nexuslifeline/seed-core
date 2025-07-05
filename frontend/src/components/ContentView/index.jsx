import Styles from './ContentView.module.scss';

const ContentView = ({ children }) => {
  return <div className={Styles.container}>{children}</div>;
};

export default ContentView;
