using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Doorcensor : MonoBehaviour
{
    public GameObject door;
    private bool doorType;
    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        
    }
    private void OnTriggerEnter(Collider other)
    {
        if(other.tag == "Player")
        {
            doorType = true;
            door.GetComponent<Animator>().SetBool("open", doorType);
        }

    }
    private void OnTriggerExit(Collider other)
    {
        if (other.tag == "Player")
        {
            doorType = false;
            door.GetComponent<Animator>().SetBool("open", doorType);
        }
    }
}
