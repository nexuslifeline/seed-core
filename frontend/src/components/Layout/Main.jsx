import { useState, useEffect } from 'react';
import { Outlet } from 'react-router-dom';

import Header from '@components/Header';
import Sidebar from '@components/Sidebar';
import SlidePanel from '@components/SlidePanel';
import { useActiveOrganization } from '@shared/store/activeOrganization';
import { LayoutStateContext } from '@shared/context/LayoutState';

import Styles from './Main.module.scss';

const Layout = () => {
  const { setActiveOrganization, activeOrganization } = useActiveOrganization();
  const [isReady, setIsReady] = useState(false);
  // Todo: move to zustand
  const [isSlideOpen, setIsSlideOpen] = useState(false);
  const [isMainNavOpen, setIsMainNavOpen] = useState(false);
  const [isMobileNavOpen, setIsMobileNavOpen] = useState(false);

  useEffect(() => {
    // For testing
    setActiveOrganization({ uuid: 'fb9200ed-f4f0-44f1-ab85-1a06aa8ef8f2' });
  }, []);

  useEffect(() => {
    if (activeOrganization?.uuid) {
      setIsReady(true);
    }
  }, [activeOrganization?.uuid]);

  return (
    <LayoutStateContext.Provider
      value={{
        isSlideOpen,
        setIsSlideOpen,
        isMainNavOpen,
        setIsMainNavOpen,
        isMobileNavOpen,
        setIsMobileNavOpen
      }}>
      <div className={Styles.container}>
        <Sidebar />
        {/* <MobileNav /> */}
        <Header />
        {isReady && (
          <div className={Styles.main}>
            <Outlet />
          </div>
        )}

        <SlidePanel />
      </div>
    </LayoutStateContext.Provider>
  );
};

export default Layout;
