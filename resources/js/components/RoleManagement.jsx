import React, { useState, useEffect } from 'react';
import axios from 'axios';

const RoleManagement = () => {
    const [roles, setRoles] = useState([]);
    const [permissions, setPermissions] = useState([]);
    const [formData, setFormData] = useState({
        name: '',
        description: '',
        permissions: []
    });

    useEffect(() => {
        fetchRoles();
        fetchPermissions();
    }, []);

    const fetchRoles = async () => {
        const response = await axios.get('/api/roles');
        setRoles(response.data);
    };

    const fetchPermissions = async () => {
        const response = await axios.get('/api/permissions');
        setPermissions(response.data);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            await axios.post('/api/roles', formData);
            fetchRoles();
            setFormData({ name: '', description: '', permissions: [] });
        } catch (error) {
            console.error('Error creating role:', error);
        }
    };

    return (
        <div>
            <h2>Role Management</h2>
            <form onSubmit={handleSubmit}>
                <div>
                    <label>Name:</label>
                    <input
                        type="text"
                        value={formData.name}
                        onChange={(e) => setFormData({...formData, name: e.target.value})}
                    />
                </div>
                <div>
                    <label>Description:</label>
                    <input
                        type="text"
                        value={formData.description}
                        onChange={(e) => setFormData({...formData, description: e.target.value})}
                    />
                </div>
                <div>
                    <label>Permissions:</label>
                    {permissions.map(permission => (
                        <div key={permission.id}>
                            <input
                                type="checkbox"
                                checked={formData.permissions.includes(permission.id)}
                                onChange={(e) => {
                                    const newPermissions = e.target.checked
                                        ? [...formData.permissions, permission.id]
                                        : formData.permissions.filter(id => id !== permission.id);
                                    setFormData({...formData, permissions: newPermissions});
                                }}
                            />
                            <span>{permission.name}</span>
                        </div>
                    ))}
                </div>
                <button type="submit">Create Role</button>
            </form>

            <h3>Existing Roles</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {roles.map(role => (
                        <tr key={role.id}>
                            <td>{role.name}</td>
                            <td>{role.description}</td>
                            <td>
                                {role.permissions.map(p => p.name).join(', ')}
                            </td>
                            <td>
                                <button onClick={() => handleDelete(role.id)}>Delete</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default RoleManagement;
