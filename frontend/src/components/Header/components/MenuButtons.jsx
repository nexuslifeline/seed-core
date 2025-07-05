import Apps from '@components/Icons/Apps';
import Bell from '@components/Icons/Bell';
import Styles from './MenuButtons.module.scss';
import classNames from 'classnames';
import Menu from '@components/Menu';
import Notifications from '@components/Header/components/NotificationDropdown';
import { withLayoutState } from '@shared/context/LayoutState';

const MenuButton = ({ button, content, hasSonar, ...props }) => {
  return (
    <Menu>
      <Menu.Button className={classNames(Styles.menuButton, hasSonar && Styles.hasSonar)} {...props}>
        {button}
      </Menu.Button>
      <Menu.Items className={Styles.items}>{content}</Menu.Items>
    </Menu>
  );
};

const Item = ({ children, hasSonar, icon: Icon, ...props }) => {
  return (
    <li className={Styles.item}>
      {children ? (
        <MenuButton {...{ button: () => <Icon className={Styles.icon} />, content: children, hasSonar }} {...props} />
      ) : (
        <button className={classNames(Styles.menuButton, hasSonar && Styles.hasSonar)} {...props}>
          <Icon className={Styles.icon} />
        </button>
      )}
    </li>
  );
};

const MenuButtons = ({ isSlideOpen, setIsSlideOpen }) => {
  const handleAppItemClick = () => setIsSlideOpen(!isSlideOpen);

  return (
    <ul className={Styles.container}>
      <Item icon={Bell} hasSonar>
        <Notifications />
      </Item>
      <Item icon={Apps} onClick={handleAppItemClick} />
    </ul>
  );
};

export default withLayoutState(MenuButtons);
