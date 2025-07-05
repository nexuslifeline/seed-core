import Styles from './NotificationDropdown.module.scss';
import Tab from '@components/Tab';
import ImgEmpty from '@components/Backgrounds/Images/Empty';
import ImageView from '@components/ImageView';
import Text from '@components/Text';
import List from '@components/Header/components/Notifications/List';

const TabPanel = ({ children, ...props }) => {
  return (
    <Tab.Panel listItemClass={Styles.listItemClass} panelItemClass={Styles.panelItemClass} {...props}>
      {children}
    </Tab.Panel>
  );
};

const Notifications = () => {
  return (
    <div className={Styles.container}>
      <div className={Styles.header}>
        <Text size={'md'}>{'Notifications'}</Text>
      </div>
      <div className={Styles.body}>
        <Tab tabListClass={Styles.tabList} panelsClass={Styles.panels}>
          <TabPanel title={'All'}>
            <List />
          </TabPanel>
          <TabPanel title={'Activity'}>
            <div>
              <ImageView img={ImgEmpty} title={'No Notifications'} description={'There are no notifications yet'} />
            </div>
          </TabPanel>
          <TabPanel title={'Billing'}>
            <div>
              <ImageView img={ImgEmpty} title={'No Notifications'} description={'There are no notifications yet'} />
            </div>
          </TabPanel>
        </Tab>
      </div>
    </div>
  );
};

export default Notifications;
