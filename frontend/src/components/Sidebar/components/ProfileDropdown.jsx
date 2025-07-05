import Menu from '@components/Menu';
import Profile from '@components/Sidebar/components/Profile';
import ProfilePhoto from '@components/ProfilePhoto';

const ProfileMenu = () => {
  return (
    <Menu>
      <Menu.Button>
        <ProfilePhoto isOnline cursorPointer />
      </Menu.Button>
      <Profile />
    </Menu>
  );
};

export default ProfileMenu;
