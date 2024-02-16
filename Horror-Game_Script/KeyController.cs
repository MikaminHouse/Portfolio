using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class KeyController : MonoBehaviour
{
    public int keyNumber;
    public string keyName;

    // Start is called before the first frame update
    void Start()
    {
        keyName = gameObject.name;
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
