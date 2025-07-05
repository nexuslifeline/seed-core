import TextInput from '@components/Form/TextInput';
import TextArea from '@components/Form/TextArea';
import Tab from '@components/Tab';
import Modal from '@components/Modal';
import Toggle from '@components/Form/Toggle';
import Button from '@components/Button';
import { useState } from 'react';
import PasswordInput from '@components/Form/PasswordInput';
import Select from '@components/Form/Select';
import Avatar from '@components/Avatar';
import Loader from '@components/Loader';
import Card from '@components/Card';
import FileUploader from '@components/FileUploader';
import File from '@components/File';
import PhoneNumber from '@components/Form/PhoneNumber';
import Badge from '@components/Badge';
import Accordion from '@components/Accordion';
import SearchInput from '@components/Form/SearchInput';
import InvalidFeedback from '@components/InvalidFeedback';

function App() {
  const [isOpen, setIsOpen] = useState(false);
  const [fruits, setFruits] = useState('');
  const [profilePhoto, setProfilePhoto] = useState(null);
  const [myFiles, setMyFiles] = useState([]);
  const items = [
    {
      header: <div>Lorem ipsum dolor sit amet.</div>,
      content: (
        <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi temporibus iste dolor illo dicta quo?</div>
      ),
    },
    {
      header: <div>Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit veniam nihil itaque..</div>,
      content: (
        <div>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt non sint illum. At expedita repellendus, earum
          aliquam amet quisquam quasi, cupiditate tempore quae necessitatibus eligendi numquam, ab ex nisi inventore.
        </div>
      ),
    },
    {
      header: <div>Lorem ipsum dolor sit amet consectetur.</div>,
      content: (
        <div>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto illo corporis assumenda deleniti,
          blanditiis veniam veritatis. Officia recusandae temporibus magnam laboriosam ducimus aliquam facilis inventore
          molestias voluptates. Veritatis recusandae cumque mollitia error consequatur, possimus consectetur?
        </div>
      ),
    },
  ];

  const onPhotoChanged = (e) => {
    const [file] = e.target.files;
    console.log(file);
    setProfilePhoto(URL.createObjectURL(file));
  };

  const onRemovePhoto = () => {
    setProfilePhoto(null);
  };

  const handMoreActionClick = (e, button) => {
    alert(button);
  };

  const SampleIcon = ({ ...props }) => {
    return (
      <svg {...props} width='24px' height='24px' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'>
        <path d='M22.987 10.25l-9 7.99c-.57.51-1.28.76-1.99.76s-1.42-.25-1.98-.74c0-.01-.01-.01-.01-.01l-.02-.02-8.98-7.98c-1.24-1.1-1.35-3.002-.25-4.242 1.1-1.24 3-1.35 4.23-.25l7.01 6.23 7.01-6.23c1.24-1.1 3.13-.99 4.24.25 1.1 1.24.98 3.13-.26 4.24z' />
      </svg>
    );
  };

  const moreActions = [
    {
      label: 'Action1',
      onClick: (e) => {
        handMoreActionClick(e, 'action 1');
      },
      icon: <SampleIcon style={{ fill: 'gray' }} />,
    },
    {
      label: 'Action2',
      onClick: (e) => {
        handMoreActionClick(e, 'action 2');
      },
      children: (
        <div style={{ display: 'flex', alignItems: 'center' }}>
          <SampleIcon style={{ marginRight: '8px' }} /> Using Children slot
        </div>
      ),
    },
    {
      label: 'Action3',
      onClick: (e) => {
        handMoreActionClick(e, 'action 3');
      },
      icon: <SampleIcon style={{ fill: 'gray' }} />,
    },
    {
      label: 'Action4',
      onClick: (e) => {
        handMoreActionClick(e, 'action 4');
      },
    },
  ];

  const [password, setPassword] = useState('');

  const buttonContainerStyle = {
    marginTop: '10px',
    display: 'flex',
    alignItems: 'center',
    gap: '6px',
  };

  const ModalContent = () => (
    <div>
      <div style={{ margin: '0 0 20px 0' }}> this is sample content props for modal</div>
      <div style={{ display: 'flex', justifyContent: 'flex-end', alignItems: 'center' }}>
        <button onClick={() => setIsOpen(false)}>Deactivate</button>
        <button style={{ marginLeft: '8px' }} onClick={() => setIsOpen(false)}>
          Cancel
        </button>
      </div>
    </div>
  );

  const onFileClick = (file) => {
    console.log(file);
    alert('file click');
  };

  const onFileRemove = (file) => {
    console.log(file);
    alert('file remove click');
  };

  const handleButtonClick = (e, desc) => {
    console.log(e.target);
    alert(desc);
  };

  const options = [
    { value: 'chocolate', label: 'Chocolate' },
    { value: 'strawberry', label: 'Strawberry' },
    { value: 'vanilla', label: 'Vanilla' },
  ];

  const onAcceptFiles = (files) => {
    //do something on files
    files.forEach((file) => {
      console.log(file);
    });

    setMyFiles((current) => [...current, ...files]);
  };

  return (
    <div style={{ padding: '30px', width: '100%', height: '100%', overflow: 'auto' }}>
      <InvalidFeedback error={'Sample Error Message'} />
      <br />
      <InvalidFeedback error={'Sample Error Message1'} />
      <br />
      <InvalidFeedback error={'Sample Error Message2'} />

      <div style={{ marginBottom: 20 }}>
        <Accordion items={items} />
      </div>

      <SearchInput placeholder='Search' />
      <br />
      <br />

      <div style={{ marginBottom: '10px', display: 'flex', gap: '10px', alignItems: 'center' }}>
        <Badge label='Badge' />
        <Badge label='Badge' variant={Badge.Variants.PRIMARY_OUTLINE} />
        <Badge label='Badge' variant={Badge.Variants.SECONDARY} />
        <Badge label='Badge' variant={Badge.Variants.SECONDARY_OUTLINE} />
      </div>

      <Card
        header={`This is a sample title`}
        footer={() => (
          <>
            <Button
              label={'Cancel'}
              variant={Button.Variants.SECONDARY_OUTLINE}
              style={{ marginLeft: 'auto', marginRight: '10px' }}
            />
            <Button label={'Save'} isBusy />
          </>
        )}>{`body test`}</Card>
      <br />
      <br />
      <PhoneNumber />
      <Loader />
      <br />
      <Toggle label={'Yes, I am above 18y/o'} />
      <br />
      <br />
      <Select
        label={'Fruits'}
        value={fruits}
        onChange={(e) => setFruits(e)}
        options={options}
        isClearable
        error={'Fruits is required.'}
      />
      <br />
      <TextInput label={'Full Name'} placeholder={'Enter Full Name'} error={null} />
      <br />
      <TextInput label={'Full Name'} placeholder={'Enter Full Name'} error={'Full name is required.'} />
      <br />
      <TextArea label={'Address'} placeholder={'Enter Address'} error={'Address is required.'} />
      <br />
      <Tab>
        <Tab.Panel title={'Full time'}>
          <h1>{'Tab 1'}</h1>
        </Tab.Panel>
        <Tab.Panel title={'Part time'}>
          <h1>{'Tab 2'}</h1>
        </Tab.Panel>
      </Tab>
      <Modal
        isOpen={isOpen}
        title={'this is a modal title'}
        size={Modal.Sizes.LARGE}
        content={<ModalContent />}></Modal>
      <button onClick={() => setIsOpen(true)}>Open Modal</button>

      <div style={buttonContainerStyle}>
        <Button onClick={(e) => handleButtonClick(e, 'primary sm button')} label={'Im a primary sm Button'} isBusy>
          <span>children content</span>
        </Button>
        <Button onClick={(e) => handleButtonClick(e, 'primary sm button')} label={'Im a primary sm Button'} />
        <Button
          onClick={(e) => handleButtonClick(e, 'primary md button')}
          label={'Im a primary md disabled Button'}
          disabled
        />
      </div>

      <div style={buttonContainerStyle}>
        <Button
          onClick={(e) => handleButtonClick(e, 'secondary sm button')}
          label={'Im a secondary sm Button'}
          variant={Button.Variants.SECONDARY}
          isBusy>
          <span>children content</span>
        </Button>
        <Button
          onClick={(e) => handleButtonClick(e, 'secondary md button')}
          label={'Im a secondary md Button'}
          variant={Button.Variants.SECONDARY}
        />
        <Button
          onClick={(e) => handleButtonClick(e, 'secondary md button')}
          label={'Im a secondary md disabled Button'}
          variant={Button.Variants.SECONDARY}
          disabled
        />
      </div>

      <div style={buttonContainerStyle}>
        <Button
          onClick={(e) => handleButtonClick(e, 'primary sm outline button')}
          label={'Im a primary outline sm Button'}
          variant={Button.Variants.PRIMARY_OUTLINE}
          isBusy>
          <span>children content</span>
        </Button>
        <Button
          onClick={(e) => handleButtonClick(e, 'primary md outline button')}
          label={'Im a primary outline md Button'}
          variant={Button.Variants.PRIMARY_OUTLINE}
        />
        <Button
          onClick={(e) => handleButtonClick(e, 'primary md outline button')}
          label={'Im a primary outline md disabled Button'}
          disabled
          variant={Button.Variants.PRIMARY_OUTLINE}
        />
      </div>

      <div style={buttonContainerStyle}>
        <Button
          onClick={(e) => handleButtonClick(e, 'secondary sm outline button')}
          label={'Im a secondary outline sm Button'}
          variant={Button.Variants.SECONDARY_OUTLINE}
          isBusy>
          <span>children content</span>
        </Button>
        <Button
          onClick={(e) => handleButtonClick(e, 'secondary md outline button')}
          label={'Im a secondary outline md Button'}
          variant={Button.Variants.SECONDARY_OUTLINE}
        />
        <Button
          onClick={(e) => handleButtonClick(e, 'secondary md outline button')}
          label={'Im a secondary outline md disabled Button'}
          disabled
          variant={Button.Variants.SECONDARY_OUTLINE}
        />
      </div>

      <div style={buttonContainerStyle}>
        <Button onClick={(e) => handleButtonClick(e, 'block button')} label={'Im a block button'} block isBusy />
      </div>

      <div style={buttonContainerStyle}>
        <Button
          onClick={(e) => handleButtonClick(e, 'block button')}
          label={'More Actions'}
          moreActions={moreActions}
          iconPlacement={'left'}
        />

        <Button
          onClick={(e) => handleButtonClick(e, 'block button')}
          label={'More Actions'}
          moreActions={moreActions}
          iconPlacement={'right'}
        />
      </div>

      <div style={{ marginTop: '20px' }}>
        <PasswordInput
          label={'Password'}
          placeholder={'Enter your password.'}
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          showStrength
          error={'Password is required'}
        />

        <ul>
          <li>Strong: 1 Uppercase, 1 Lowercase, 1 digit, 1 special char, 8 char</li>
          <li>Medium: atleast 6 char, no digit || no upper || no lowercase || no special char</li>
          <li>Weak: not strong and not medium</li>
        </ul>
      </div>

      <div style={{ display: 'flex', alignItems: 'center', gap: '40px' }}>
        <Avatar
          src={profilePhoto}
          onChange={(e) => onPhotoChanged(e)}
          onRemove={() => onRemovePhoto()}
          allowUpload
          round
          containerProps={{ borderColor: 'red', borderWidth: '4px' }}
          initials={'AB'}
          profileId={1}
        />

        <Avatar
          src={profilePhoto}
          onChange={(e) => onPhotoChanged(e)}
          onRemove={() => onRemovePhoto()}
          allowUpload
          round
          containerProps={{
            borderColor: 'red',
            borderWidth: '1px',
            width: 60,
            height: 60,
          }}
          initials={'AB'}
          profileId={99}
        />

        <Avatar
          src={profilePhoto}
          onChange={(e) => onPhotoChanged(e)}
          onRemove={() => onRemovePhoto()}
          allowUpload
          containerProps={{ borderColor: 'blue', borderWidth: '4px', height: 120, width: 120 }}
          initials={'CD'}
          profileId={35}
        />

        <Avatar
          src={profilePhoto}
          onChange={(e) => onPhotoChanged(e)}
          onRemove={() => onRemovePhoto()}
          allowUpload
          containerProps={{ borderColor: 'blue', borderWidth: '4px', height: 200, width: 200 }}
          initials={'EF'}
          round
          profileId={139}
        />

        <Avatar
          src={profilePhoto}
          onChange={(e) => onPhotoChanged(e)}
          onRemove={() => onRemovePhoto()}
          allowUpload
          containerProps={{ borderColor: 'blue', borderWidth: '4px', height: 300, width: 300 }}
          initials={'GH'}
          profileId={58}
        />
      </div>
      <div style={{ marginTop: '20px', width: '300px', height: '200px' }}>
        <FileUploader onDrop={(files) => onAcceptFiles(files)} />
      </div>

      <div style={{ marginTop: '20px', width: '400px' }}>
        Accepted Files :
        {myFiles.map((file, index) => {
          return <File file={file} key={index} onClick={() => onFileClick(file)} onRemove={() => onFileRemove(file)} />;
        })}
      </div>
    </div>
  );
}

export default App;
