import React from 'react';
import { Modal, Button } from 'react-bootstrap';

interface LookUsersReseauModalProps {
  show: boolean;
  handleClose: () => void;
  users: Array<{ id: number; name: string }>;
  onAddUser: () => void;
  onDeleteUser: (id: number) => void;
}

const LookUsersReseauModal: React.FC<LookUsersReseauModalProps> = ({ show, handleClose, users, onAddUser, onDeleteUser }) => {
  return (
    <Modal show={show} onHide={handleClose}>
      <Modal.Header closeButton>
        <Modal.Title>Users Reseau</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <ul>
          {users.map(user => (
            <li key={user.id}>
              {user.name}
              <Button variant="danger" onClick={() => onDeleteUser(user.id)} style={{ marginLeft: '10px' }}>
                Supprimer
              </Button>
            </li>
          ))}
        </ul>
      </Modal.Body>
      <Modal.Footer>
        <Button variant="primary" onClick={onAddUser}>
          Ajouter un utilisateur
        </Button>
        <Button variant="secondary" onClick={handleClose}>
          Fermer
        </Button>
      </Modal.Footer>
    </Modal>
  );
};

export default LookUsersReseauModal;