import Styles from './LogoSection.module.scss';
import LogoWhiteFull from '@components/Icons/Logo/WhiteFull';

const LogoSection = () => {
  return (
    <div className={Styles.container}>
      <LogoWhiteFull className={Styles.logo} />
      <p className={Styles.subheadline}>{`A workplace to grow your business`}</p>
      {/* <div className={Styles.logoHeadlines}>
        <h3 className={Styles.headline}>{`Seed Platform`}</h3>
        <p className={Styles.subheadline}>{`A workplace to grow your business`}</p>
      </div> */}
    </div>
  );
};

export default LogoSection;
