import Styles from './SubPanel.module.scss';
// import LogoBlackFull from '@components/Icons/LogoBlackFull';
import classNames from 'classnames';
import SubPanelSection from './SubPanelSection';

const SubPanel = ({ linkGroups, isCollapse, setHasChildren, ...props }) => {
  return (
    <div className={classNames(Styles.container, isCollapse && Styles.collapse)}>
      {linkGroups.map((group, idx) => {
        return <SubPanelSection key={idx} title={group.text} links={group.children} />;
      })}
    </div>
  );
};

export default SubPanel;
