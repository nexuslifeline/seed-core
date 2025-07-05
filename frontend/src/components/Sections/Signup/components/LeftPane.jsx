import Panel from '@components/Panels';
import LogoSection from '@components/Sections/Logo';
import OverviewSlides from '@components/Sections/OverviewSlides';
import Rectangles from '@components/Backgrounds/Rectangles';
import Styles from './LeftPane.module.scss';

const LeftPane = () => {
  return (
    <Panel className={Styles.panel} hasBackground>
      <LogoSection />
      <OverviewSlides />
      <Rectangles />
    </Panel>
  );
};

export default LeftPane;
