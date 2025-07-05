import Panel from '@components/Panels';
import LogoSection from '@components/Sections/Logo';
import OverviewSlides from '@components/Sections/OverviewSlides';
import Circles from '@components/Backgrounds/Circles';
import Workflow from '@components/Backgrounds/Images/Workflow';
import Styles from './RightPane.module.scss';

const RightPane = () => {
  return (
    <Panel className={Styles.panel} hasBackground>
      <LogoSection />
      <OverviewSlides />
      <Circles />
      <Workflow className={Styles.bgImage} />
    </Panel>
  );
};

export default RightPane;
