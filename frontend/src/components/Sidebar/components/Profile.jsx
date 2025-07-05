import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';

import ProfilePhoto from '@components/ProfilePhoto';
import { useAuthStore } from '@store/auth';
import Text from '@components/Text';
import Button from '@components/Button';
import Menu from '@components/Menu';
import Token from '@lib/token';

import Styles from './Profile.module.scss';

const Profile = () => {
  const navigate = useNavigate();
  const { revokeAuth } = useAuthStore();
  const [isLoading, setIsLoading] = useState(false);

  const handleSignout = () => {
    setIsLoading(true);

    setTimeout(() => {
      setIsLoading(false);
      Token.remove();
      revokeAuth();
      navigate('/');
    }, 1000);
  };

  return (
    <Menu.Items as='div' direction='top-right'>
      <div className={Styles.container}>
        <div className={Styles.header}>
          <ProfilePhoto size={40} />
          <div className={Styles.profile}>
            <Text size={'md'}>{'Paul Christian Rueda'}</Text>
            <Text variant='description'>{'Administrator'}</Text>
          </div>
        </div>
        <div className={Styles.body}>
          <div className={Styles.menus}>
            <Menu.Item as={Link} to='/account' className={Styles.menuItem}>
              {/* <EditProfile className={Styles.icon} /> */}
              <div>
                <Text size={'md'}>{'Account'}</Text>
                <Text size={'xs'} variant='description'>
                  {'Enter your Account & Profile Info'}
                </Text>
              </div>
            </Menu.Item>
            <Menu.Item as={Link} to='/company' className={Styles.menuItem}>
              {/* <Building className={Styles.icon} /> */}
              <div>
                <Text size={'md'}>{'Company'}</Text>
                <Text size={'xs'} variant='description'>
                  {'Enter your Company Details'}
                </Text>
              </div>
            </Menu.Item>
            <Menu.Item as={Link} to='/preferences' className={Styles.menuItem}>
              {/* <Preferences className={Styles.icon} /> */}
              <div>
                <Text size={'md'}>{'Preference'}</Text>
                <Text size={'xs'} variant='description'>
                  {'Configure your App Preference'}
                </Text>
              </div>
            </Menu.Item>
          </div>
        </div>
        <div className={Styles.footer}>
          <Button
            onClick={handleSignout}
            isBusy={isLoading}
            variant={Button.Variants.SECONDARY_OUTLINE}
            style={{ marginTop: 'auto' }}
            block>
            {'Sign out'}
          </Button>
        </div>
      </div>
    </Menu.Items>
  );
};

export default Profile;
