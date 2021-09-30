<?php

/**
 * Manager para Rendicion Estado
 *
 * @author Marcos
 * @since 29-09-2021
 */
class RendicionEstadoManager extends EntityManager{

	public function getDAO(){
		return DAOFactory::getRendicionEstadoDAO();
	}

	public function add(Entity $entity) {

		parent::add($entity);

    }

     public function update(Entity $entity) {


		parent::update($entity);
     }




	/**
     * se elimina la entity
     * @param int identificador de la entity a eliminar.
     */
    public function delete($id) {

		parent::delete( $id );


    }




}
?>
