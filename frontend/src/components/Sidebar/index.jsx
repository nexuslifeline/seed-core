import Styles from './Sidebar.module.scss';
import SubPanel from './components/SubPanel';
import MainPanel from './components/MainPanel';
import { navLinks } from '@router/nav';
import { useLocation } from 'react-router-dom';
import { withLayoutState } from '@shared/context/LayoutState';
import classNames from 'classnames';
import CaretLeft from '@components/Icons/CaretLeft';

const Sidebar = ({ isMainNavOpen, isMobileNavOpen, setIsMobileNavOpen }) => {
  const location = useLocation();

  const navIndex = navLinks.findIndex(({ groups }) =>
    groups?.some(({ children }) => children?.some((child) => child?.to === location?.pathname))
  );

  const linkGroups = navLinks?.[navIndex]?.groups || [];

  return (
    <div className={classNames(Styles.container, isMobileNavOpen && Styles.mobileOpen)}>
      <button className={Styles.btnCollapse} onClick={() => setIsMobileNavOpen(false)}>
        <CaretLeft className={Styles.icon} />
      </button>
      <MainPanel activeIndex={navIndex} />
      <SubPanel linkGroups={linkGroups} isCollapse={!linkGroups?.length > 0 || isMainNavOpen} />
    </div>
  );
};

export default withLayoutState(Sidebar);
