import Styles from './Header.module.scss';
import Menu from './components/MenuButtons';
import SearchBar from './components/SearchBar';
import Hamburger from '@components/Hamburger';
import { withLayoutState } from '@shared/context/LayoutState';

const Header = ({ isMainNavOpen, setIsMainNavOpen, setIsMobileNavOpen, isMobileNavOpen }) => {
  return (
    <div className={Styles.container}>
      <button className={Styles.btnMenu} onClick={() => setIsMainNavOpen(!isMainNavOpen)}>
        <Hamburger isArrow={!isMainNavOpen} />
      </button>
      <button className={Styles.btnMobile} onClick={() => setIsMobileNavOpen(!isMobileNavOpen)}>
        <Hamburger />
      </button>
      <SearchBar />
      <Menu />
    </div>
  );
};

export default withLayoutState(Header);
