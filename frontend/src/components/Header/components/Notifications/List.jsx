import ActivityItem from '@components/Header/components/Notifications/ActivityItem';
import Styles from './List.module.scss';

const List = (props) => {
  return (
    <div className={Styles.container}>
      {Array.from({ length: 15 }).map((v, idx) => (
        <ActivityItem key={idx} />
      ))}
    </div>
  );
};

export default List;
