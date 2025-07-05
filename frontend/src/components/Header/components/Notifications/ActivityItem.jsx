import Styles from './ActivityItem.module.scss';
import ProfilePhoto from '@components/ProfilePhoto';
import Text from '@components/Text';

const ActivityItem = (props) => {
  return (
    <div className={Styles.row}>
      <ProfilePhoto size={36} />
      <div className={Styles.details}>
        <Text variant='description' size='sm'>
          <Text size='sm' as='span'>
            {'Paul Christian Rueda'}
          </Text>
          {' created an invoice.'}
        </Text>
        <Text as='span' size='xs' color='light'>
          {'Thu at 12:02 PM'}
        </Text>
      </div>
    </div>
  );
};

export default ActivityItem;
